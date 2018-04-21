; chgdisp 1,640,480
; bgscr 0, 640, 480,,0,0
title "ふらふらコスモノート"

chipbuf = ginfo_newid
buffer chipbuf
picload "res/mapchip.png"

charbuf = ginfo_newid
buffer charbuf
picload "res/spaceman.png"

bgbuf = ginfo_newid
buffer bgbuf
picload "res/bg.png"

titlebuf = ginfo_newid
buffer titlebuf
picload "res/title.png"

shipbuf = ginfo_newid
buffer shipbuf
picload "res/spaceship.png"

barbuf = ginfo_newid
buffer barbuf
picload "res/bar.png"

mci "open res/collide.wav alias collide type mpegvideo"
mci "open res/select.wav alias select type mpegvideo"
mci "open res/enter.wav alias enter"
mci "open res/flying.wav alias flying"
mci "open res/michimichi.wav alias michido"
mci "open res/multitask.wav alias multitask"
mci "open res/F.wav alias F"

mci "setaudio collide volume to 50"
mci "setaudio select volume to 50"
mci "setaudio flying volume to 50"


*entrypoint
gosub *xorshift_init

mci "play multitask from 0"

gsel 0
gmode 4,,,256

mode = 0

descs = "ストーリーモードだ。\n終わりがあるぞ", "ノーマルモードだ。\nいきなりゲームが始まるぞ。\n画面から出たら\nゲームオーバだからな", "ハードモードだ。\n得点率が高くてお得だ", "いろんなまよいひこうしの\n点数がみられるぞ", "このゲームの\n製作を助けてくれた\n人たちだ", "すべておしまいだ"
modenames = "Story", "Normal", "Hard", "Ranking", "Credit", "Exit"
modenum = length(modenames)


repeat
	redraw 0
	
	stick key
	if key&2 {
		mode--
		mci "play select from 0"
	}
	if key&8 {
		mode++
		mci "play select from 0"
	}
	if key&32 {
		mci "play enter from 0"
		break
	}
	if mode < 0 {
		mode = modenum - 1
	}
	mode = (mode \ modenum)
	
	pos 0,0
	gcopy bgbuf,0,0,640,480

	pos 100, 50
	color 1,1,1
	gcopy titlebuf, 0, 0, 250, 75
	
	x = 380
	y = 170
	
	font msgothic, 36
	repeat modenum
		pos x,y
		color 255,255,255
		mes modenames(cnt)
		pos x-1,y-1
		color 0,0,255
		mes modenames(cnt)
		y += 50
	loop
	
	color 1,1,1
	pos 340, mode * 50 + 170
	gcopy charbuf, 0, 0, 32,32
	
	gmode 3,,,200	
	color 255,255,255
	grect 150, 200, 0, 250, 100
	gmode 4,,,256
	
	font msgothic, 20
	pos 25,150
	color 0,0,0
	mes descs(mode)
	
	pos 25,300
	font msgothic, 32
	color 255,255,255
	mes "↑↓キーで選択\nEnterで決定"
	
	redraw 1
	await 16
loop

storymode = 0
if mode = 0 {
	storymode = 1
	mci "stop multitask"
	mci "play F from 0"
	c = 0
	mess = "…………おい", "おい！！", "……聞こえるか？", "…………元気で何よりだ。", "……私か？\nはっはっはっ、忘れたか。", "まあいい、大事なのは君のことだ。", "我々は迷子になってしまった君を、\n宇　宙　船で救いに来たのだ。", "君からおよそ10000mの距離にいるんだが、\nちいさいちりが邪魔で助けに行くことができない", "君は自力でこっちまでこられるな？", "右キーで右噴射、左キーで左噴射だ。\n同時押しでまっすぐすすめるからな", "画面から出たら、ゲーム・オーバだから、気をつけろよ", "…………では、健闘を祈る"
	font msgothic, 24
	repeat 
		repeat 25
			redraw 0
	
			stick key
			if key & 128 {
				mci "stop F"
				goto *entrypoint
			}
			
			pos 0,0
			color 1,1,1
			gcopy bgbuf, 0, 0, 640, 480
		
			pos 20, 100
			color 10*cnt,10*cnt,10*cnt
			mes mess(c)

			redraw 1
	
			await 16
		loop
	
		repeat 
			stick key
			if key & 128 {
				mci "stop F"
				goto *entrypoint
			}
			if key & 32 {
				mci "play enter from 0"
				c++
				if c >= length(mess) {
					mci "stop F"
					wait 10
					goto *story
				}
				break
			}
			await 16
		loop
	loop
	
	stop
}

if mode = 3 {
	notesel ranking
	noteload "ranking.txt"
	
	data = ""
	repeat notemax / 2
		noteget name, cnt*2
		noteget point, cnt*2 + 1
	
		data += strf("%d位 %7d点　%s\n", cnt+1, point, name)
	loop
	
	y = 480
	font msgothic, 26
	repeat
		redraw 0
	
		color 1,1,1
		pos 0,0
		gcopy bgbuf,0,0,640,480
	
		pos 20, y
		color 255,255,255
		mes data
	
		stick key,32
		if key & 32 {
			y-=3
		}
	
		y--
	
		if y < -(notemax / 2 * 26) {
			mci "play enter from 0"
			goto *entrypoint
		}
		
		redraw 1
		await 16
	loop
}


if mode = 4 {
	color 1,1
	pos 0,0
	gcopy bgbuf,0,0,640,480
	
	redraw 1
	
	font msgothic, 26
	color 255,255,255
	
	works = "原案・製作", "アルゴリズム・制作補助", "音楽", "", "グラフィック", "背景", "シナリオ原案", "テストプレイ", "", "", ""
	names = "ふるつき", "ptr-yudai", "ちげ", "かおす",  "ちげ", "thrust2799", "kyumina8376", "ptr-yudai", "Daisuke", "iikyara", "kaiwai"
	
	repeat length(works)
		pos 20, 30 * (cnt +1)
		mes works(cnt)
		pos 400, 30 * (cnt + 1)
		mes names(cnt)
	loop
	
	
	pos 100, 400
	mes "Enterキーでもどる"
	
	
	repeat
		stick key
		if key & 32 {
			mci "play enter from 0"
			goto *entrypoint
		}
		await 16
	loop
}

if mode = 5 {
	wait 35
	end
}


*story
mci "stop multitask"


hardmode = 0
if mode = 2 {
	hardmode = 1
}
meters = 00000.0
collide = 0

mapw = 20
maph = 15
chipw = 32
chiph = 32

dim map1,mapw*maph*2
dim map2,mapw*maph*2

repeat maph
	y = cnt*mapw
	map1(y) = 2
	repeat 6
		map1(y+cnt+1) = 1
		map1(y+cnt+7) = 255
		map1(y+cnt+13) = 1
	loop
	map1(y+mapw-1) = 2
loop

genfield_w = mapw
genfield_h = maph
genfield_road_min_w = 5
genfield_road_w = 7
genfield_x = 7
genfield_space = 255
genfield_edge = 2
genfield_obstacle = 1

gosub *genfield

repeat mapw*maph
	map1(cnt + mapw*maph) = genfield_result(cnt)
loop

repeat mapw*maph*2
	map2(cnt) = 255
loop

cmode = 0
cx = 320.0
cy = 100.0
dcx = 0
dcy = 0
r = 5.0
l = 0.0
dl = 0.1
deg = 180.0
ddeg = 0.0

endflag = 0

doffsety = 1.0

offsety = 0.0
mapy = 0

shipy = -1
storyclear = 0

life = 100
energy = 50

if hardmode = 1 {
	dl = 0.3
	doffsety = 2.0
}

start = 1
gmode 4,,,0

mci "play michido from 0"

repeat
	redraw 0
	
	if endflag < 0 {
		goto *endflag_a
	}
	
	ddeg *= 0.4
	cmode = 0
	stick key,1+4
	if (key&1) {
		; 左
		ddeg -=4.0
		flying++
		cmode += 1
		energy--
	}
	if (key&4) {
		; 右
		ddeg +=4.0
		flying++
		cmode += 2
		energy--
	}
	if (storymode = 1) & (energy < 0) {
		ddeg  = 0.0
		flying = 0
		cmode = 0
		energy = 0
		l *= 0.7
	}
	
	if ((key&1) | (key&4)) = 0 {
		flying = 0
		energy++
		if energy > 50 {
			energy = 50
		}
	}
	if (key&1) | (key&4) {
		l+=dl
	} else : if l > 0 {
		l *= 0.93
	}

*endflag_a
	deg += ddeg
	rad = deg2rad(deg)
		
	cx = cx + l*sin(rad) + dcx
	cy = cy + l*cos(rad) + dcy + (doffsety * 0.3)
	
	if (cx < 0) | (cy < 0) | (cx >= ginfo_sx) | (cy >= ginfo_sy) & endflag >= 0 {
		flying = 0
		endflag = -256
	}
	
	dcx = 0.0
	dcy = 0.0
	
	
	;; detect collision
	
	if (shipy > 0) & (storyclear = 0) {
		if (cx >= 200) & (cx + chipw <= 500) & (cy + chipw >= shipy) & (cy <= shipy + 80) {
			l = 0.0
			endflag = -250
			storyclear = 1
		}
	}
	
	colliding = 0
	bx = (0 + cx) / chipw
	by = (0 + cy) / chiph
	
	colx = ginfo_sx
	coly = ginfo_sy

	if endflag < 0 {
		goto *endflag_b
	}


	dx = -1,0,1
	dy = -1,0,1

	repeat 3
		yi = by + dy(cnt)
		if yi < 0 {
			continue
		}
		repeat 3
			xi = bx + dx(cnt)
			if xi < 0 {
				continue
			}
			x = xi * chipw + ( chipw/2 )
			y = yi * chiph + ( chiph/2 ) - offsety
		
			if ((cx-x)*(cx-x) + (cy-y)*(cy-y)) < 32*32 {
				if map1((mapy+yi)*mapw + xi) != 255 {
	
					colx = x-chipw/2
					coly = y-chiph/2
	
					dcx = 1.0*cx - x
					dcy = 1.0*cy - y
	
					collide++
					
	
					if collide = 1 {
						nomiss = 5 * meters
					}
					colliding = 1
	
					
					life--
				}
			}
			
		loop
	loop

	if (storymode = 1) & (life <= 0) {
		endflag = -50
	}
	
*endflag_b
	
	if colliding = 1 {
		mci "play collide from 0"
	}
	if flying = 1 {
		mci "play flying from 0"
	}
	if flying > 0 {
		mci "status flying mode"
		if refstr = "stopped" {
			mci "stop flying"
			mci "play flying from 0"
		}
	}
	if flying = 0 {
		mci "stop flying"
	}
	
	color 255,255,255
	boxf
	
	color 1,1,1
	pos 0,0
	gcopy bgbuf,0,0,640,480
	
	color 255,0,128
	boxf colx, coly, colx + chipw, coly + chiph
	
	;; draw mapchip
	for y, 0, 16
		for x,0,mapw

			c = map1((mapy+y)*mapw+x)
			if c == 255 {
				_continue
			}
	
			pos x*chipw, y*chiph - offsety
			color 1,1,1
			gcopy chipbuf, c*chipw,0,chipw,chiph
	
			c = map2((mapy+y)*mapw+x)
			if c == 255 {
				_continue
			}
	
			pos x*chipw, y*chiph - offsety
			color 1,1,1
			gcopy chipbuf, c*chipw,0,chipw,chiph
		next
	next
	
	offsety += doffsety
	meters += doffsety
	
	if offsety >= chiph {
		offsety = 0.0
		mapy += 1
		if mapy > maph - 1 {
			repeat mapw*maph
				map1(cnt) = map1(cnt+mapw*maph)	
			loop
			if meters > 5000 {
				doffsety = 2.0
				if hardmode = 1 {
					doffsety = 2.5
				}
			}
			if (meters > 7500) & (storymode = 1) {
				genfield_road_w = 3
				genfield_road_min_w = 2
			}
			if meters > 10000 {
				genfield_road_w = 5
				genfield_road_min_w = 3
			}
			if meters > 20000 {
				genfield_road_w = 3
				genfield_road_min_w = 2
			}
			if meters > 25000 {
				genfield_road_w = 5
				genfield_road_min_w = 2
			}
			if meters > 30000 {
				gosub *xorshift
				genfield_road_w = abs(stat \ 6) + 3
				gosub *xorshift
				genfield_road_min_w = abs(stat \ (genfield_road_w - 1) ) + 2
				gosub *xorshift
				doffsety = (1.0 * abs(stat \ 30) + 1.0) / 10 + 1.0
			}
			
			gosub *genfield
			repeat mapw*maph
				map1(cnt+mapw*maph) = genfield_result(cnt)
			loop
			mapy = 0
		}
	}
	
	if storyclear = 0 {	
		pos cx,cy	
		color 1,1,1
		grotate charbuf, cmode*chipw, 0, M_PI - rad, 32, 32
	}
	
	if (storymode = 1) & (meters >10000) & (shipy = -1) {
		shipy = 480.0
	}
	if shipy > 0 {
		shipy -= 0.2
		pos 200, shipy
		gcopy shipbuf, 0,0, 300, 79
	}
	
	if 1 * meters \ 1000 < 200 {
		color 255,255,255
		font "Consolas", 32, 
		pos 0,0
		mes "" + meters + "m"
		pos 2,0
		mes "" + meters + "m"
		pos 0,2
		mes "" + meters + "m"
		pos 2,2
		mes "" + meters + "m"
		pos 1,1
		color 0,0,0
		mes "" + meters + "m"
	}
	
	if storymode = 1 {
		gmode 3,,,200
		color 255,255,255
		grect 440, 25, 0, 400, 50
		gmode 4,,,255
		msg = "左右キーを押してジェット噴射だ！"
	
		if meters > 1000 {
			msg = "よし！　いい調子だ！"
		}
		if meters > 2000 {
			msg = "ジェットエネルギーは大事にな！"
		}
		if meters > 3000 {
			msg = "上を向いて落ちていくといいぞ！"
		}
		if meters > 4000 {
			msg = "左右キーで微調整するんだ！"
		}
		if meters > 5000 {
			msg = "早くなるぞ！　気をつけろ！"
		}
		if meters > 6000 {
			msg = "ぶつかりすぎると死ぬかもな"
		}
		if meters > 7000 {
			msg = "そろそろ慣れてきたころか？"
		}
		if meters > 8000 {
			msg = "なんかせまくなってないか……？"
		}
		if meters > 9000 {
			msg = "あとひといきだ！！！"
		}
		
		
		pos 240, 10
		font msgothic, 26
		color 0,0,0
		
		mes msg
	}
	if storymode = 1 {
		pos ((100.0 - life) / 100) * 640, 50
		gcopy barbuf, ((100.0 - life) / 100) * 640, 0, 640, 20
		
		pos ((50.0 - energy) / 50) * 640, 80
		gcopy barbuf, ((50.0 - energy) / 50) * 640, 0, 640, 20
		
		font msgothic, 20
		color 0,0,0
		pos 550, 50
		mes "HP"
		pos 550, 80
		mes "Energy"
		
	}
	
	
	if endflag < 0 {
		gmode 4,,,-endflag
		endflag++
		if endflag = 0 {
			gmode 4,,,256
			goto *gameover
		}
	}
	
	if start > 0 {
		start++
		gmode 4,,,start
		if start = 256 {
			start = 0
		}
		
	}
	
	redraw 1
	
	mci "status michido mode"
	if (refstr = "stopped") {
		if (endflag = 0) & (mode != 2) {
			mci "play michido from 0"
		}
	}
	
	await 16
loop

*gameover
	mci "stop michido"
	
	if storymode = 1 {
		if storyclear = 1 {
			goto *gameclear
		}
		font msgothic, 70
		repeat
			redraw 0
			color 1,1,1
			pos 0,0
			gcopy bgbuf, 0, 0, 640, 480
	
			pos 300, 200
			color 128, 0, 0
			mes "GAME OVER"
	
			stick key
			if key & 32 {
				goto *entrypoint
			}
			
			redraw 1
			await 16
		loop
	}
	
	font msgothic, 24	

	if hardmode = 1 {
		hard = 2*meters
	}
	else {
		hard = 0
	}
	if collide = 0 {
		nomiss = 6 * meters
	}
	bonuss = (1 * meters / 10000 * 20000)
	score = 0+meters - 50 * collide + nomiss + hard + bonuss
	
	notesel ranking
	noteload "ranking.txt"
	
	rank = notemax / 2
	repeat notemax / 2
		noteget pt, cnt*2+1
		if (0+pt) < score {
			rank = cnt
			break
		}
	loop
			
	color 1,1,1
	pos 0,0
	gcopy bgbuf, 0,0, 640, 480

	color 255,255,255
	pos 12, 12
	mes "深さ"
	pos 300, 12
	mes "" + meters + "m"

	pos 12, 60
	mes "ぶつかった回数"
	pos 300, 60
	mes "" + collide + "回"

	pos 12, 108
	mes "ノーミスボーナス"
	pos 300, 108
	mes "" + nomiss + "点"

	pos 12, 156
	mes "到達ボーナス"
	pos 300, 156
	mes "" + bonuss + "点"

	pos 12, 204
	mes "ハードモードボーナス"
	pos 300, 204
	mes "" + hard + "点"

	pos 12, 252
	mes "最終スコア"
	pos 300, 252
	mes "" + score + "点"

			
	redraw 1
	
	hyoutei = "C"
	
	if score > 10000 {
		hyoutei = "B"
	}
	if score > 20000 {
		hyoutei = "B"
	}
	if score > 50000 {
		hyoutei = "A"
	}
	if score > 100000 {
		hyoutei = "S"
	}
	if score > 200000 {
		hyoutei = "SS"
	}
	if score > 300000 {
		hyoutei = "SSS"
	}
	hyoutei += " " + (rank + 1) + "位"
	
	wait 100
	
	font msgothic,32
	pos 12, 400
	mes "ランク："
	
	wait 100
	
	mci "play enter from 0"
	pos 150, 400
	mes hyoutei

	pos 400, 300
	sdim name
	mes "お名前"

	input name, 200, 20, 64
	onkey gosub *onreturn
	
	button "記録する", *save
	button "記録しない", *nonsave
	
	stop
	
*gameclear
	mci "play F from 0"
	c = 0
	dim mess, 0
	mess = "いやあ！　よく還ってきたな！", "もう迷子になるなよ……", "ところで、今回君は" + (100 - life) + "回もぶつかったらしいな", "まあ無事ならいいか…………あっはっは"
	font msgothic, 24
	repeat 
		repeat 25
			redraw 0
			
			pos 0,0
			color 1,1,1
			gcopy bgbuf, 0, 0, 640, 480
		
			pos 20, 100
			color 10*cnt,10*cnt,10*cnt
			mes mess(c)

			redraw 1
	
			await 16
		loop
	
		repeat 
			stick key
			if key & 32 {
				mci "play enter from 0"
				c++
				if c >= length(mess) {
					mci "stop F"
					wait 10
					goto *storyend
				}
				break
			}
			await 16
		loop
	loop
*storyend
	font msgothic, 70
	mci "play select from 0"
	repeat
			redraw 0
			color 1,1,1
			pos 0,0
			gcopy bgbuf, 0, 0, 640, 480
	
			pos 200, 200
			color 0,128,255
			mes "GAME CLEAR"
	
			stick key
			if key & 32 {
				goto *entrypoint
			}
			
			redraw 1
			await 16
		loop
	
*onreturn
	if wparam = 13 {
		objsel -1
		if stat = 0 {
			wait 50
			goto *save
		}
	}
	return
	
*nonsave
	cls
	goto *entrypoint
*save
	cls
	
	noteadd name, rank*2		; 挿入
	noteadd "" + (0 + score), rank*2+1
	notesave "ranking.txt"
	goto *entrypoint

*xorshift_init
	randomize
	xorshift_value = rnd(10000000)
	return 
	
*xorshift
	xorshift_value = xorshift_value ^ (xorshift_value << 13)
	xorshift_value = xorshift_value ^ (xorshift_value >> 17)
	xorshift_value = xorshift_value ^ (xorshift_value << 5)
	return xorshift_value

;; フィールドを生成する
;; genfield_w
;; genfield_h
;; genfield_road_w
;; genfield_road_min_w
;; genfield_x
;; genfield_space
;; genfield_edge
;; genfield_obstacle
;; 
*genfield
	dim genfield_result, genfield_h*genfield_w
	repeat genfield_h * genfield_w
		genfield_result(cnt) = genfield_obstacle
	loop
	repeat genfield_h
		genfield_result(cnt * genfield_w) = genfield_edge
		genfield_result(cnt * genfield_w + genfield_w - 1) = genfield_edge
	loop
	
	genfield_y = 0
	
	while genfield_y < genfield_h
		gosub *xorshift
		genfield_gap = stat \ (genfield_road_w - genfield_road_min_w  + 1)

		gosub *xorshift
		genfield_road_w_gap = stat \ (genfield_road_r + 1)
	
		
		if genfield_gap < 0 {
			if genfield_x + genfield_gap - genfield_road_w_gap >= genfield_w - 1 - genfield_road_min_w {
				_continue
			}
			if genfield_x + genfield_gap + genfield_road_w <= genfield_road_min_w + 1 {
				_continue
			}
		}
		else {
			if genfield_x + genfield_gap >= genfield_w - 1 - genfield_road_min_w {
				_continue
			}
			if genfield_x + genfield_gap + genfield_road_w + genfield_road_w_gap <= genfield_road_min_w + 1 {
				_continue
			}
		}
		
		genfield_x += genfield_gap
	
		
		repeat genfield_road_w + genfield_road_w_gap
			genfield_point_x = genfield_x + cnt 
			if genfield_gap < 0 {
				genfield_point_x -= genfield_road_w_gap
			}
			if genfield_point_x <= 1 {
				continue
			}
			if genfield_point_x + 1 >= genfield_w {
				continue
			}
	
			genfield_result(genfield_y * genfield_w + genfield_point_x) = genfield_space
		loop
		genfield_y++
	wend
	
	return
	
