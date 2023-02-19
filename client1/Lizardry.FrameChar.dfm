object FrameChar: TFrameChar
  Left = 0
  Top = 0
  Width = 527
  Height = 436
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object PageControl1: TPageControl
    Left = 0
    Top = 0
    Width = 527
    Height = 436
    ActivePage = TabSheet2
    Align = alClient
    TabOrder = 0
    object TabSheet1: TTabSheet
      Caption = #1069#1082#1080#1087#1080#1088#1086#1074#1082#1072
      object ttWeapon: TLabel
        Left = 230
        Top = 16
        Width = 66
        Height = 21
        Caption = 'Weapon'
      end
      object ttArmor: TLabel
        Left = 230
        Top = 43
        Width = 55
        Height = 21
        Caption = 'Armor'
      end
      object Label2: TLabel
        Left = 136
        Top = 16
        Width = 88
        Height = 21
        Caption = #1042' '#1088#1091#1082#1072#1093':'
      end
      object Label3: TLabel
        Left = 136
        Top = 43
        Width = 88
        Height = 21
        Caption = #1053#1072' '#1090#1077#1083#1077':'
      end
      object imPortret: TImage
        Left = 16
        Top = 16
        Width = 105
        Height = 105
        Stretch = True
      end
    end
    object TabSheet2: TTabSheet
      Caption = #1048#1085#1074#1077#1085#1090#1072#1088#1100
      ImageIndex = 1
      object SG: TStringGrid
        Left = 0
        Top = 32
        Width = 519
        Height = 304
        Align = alClient
        Color = clBtnFace
        RowCount = 101
        Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine, goRowSelect]
        ScrollBars = ssVertical
        TabOrder = 0
        OnClick = SGClick
        OnDblClick = SGDblClick
        ExplicitTop = 72
        ExplicitHeight = 264
        ColWidths = (
          64
          64
          64
          64
          64)
      end
      object Panel1: TPanel
        Left = 0
        Top = 0
        Width = 519
        Height = 32
        Align = alTop
        Caption = '0/100'
        TabOrder = 1
        object SpeedButton1: TSpeedButton
          Left = 1
          Top = -3
          Width = 32
          Height = 32
          Flat = True
          Glyph.Data = {
            36030000424D3603000000000000360000002800000010000000100000000100
            18000000000000030000C40E0000C40E00000000000000000000FFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFF606060FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            606060FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF606060FFFFFFFFFFFFFFFFFF17
            A2CAFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFF0F6C88FFFFFF17A2CAFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF17A2CA0F6C88BA
            9A9CFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFF17A2CA0F6C88808080CCB5B7BA9A9CFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF17A2CAFFFFFFCCB5B7E6DBDC80
            8080CCB5B7BA9A9CFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFCCB5B7E6DBDC808080CCB5B7BA9A9CFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFCC
            B5B7E6DBDC808080CCB5B7BA9A9CFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFCCB5B7E6DBDC808080CCB5B7BA9A
            9CFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFCCB5B7E6DBDC808080CCB5B7BA9A9CFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFCCB5B7E6DBDC8080
            80BA9A9CBA9A9CFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFCCB5B7CCB5B7BA9A9CBA9A9CFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFCCB5
            B7CCB5B7BA9A9CFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
            FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF}
          OnClick = SpeedButton1Click
        end
      end
      object Panel2: TPanel
        Left = 0
        Top = 336
        Width = 519
        Height = 64
        Align = alBottom
        TabOrder = 2
        object ttInfo: TLabel
          Left = 1
          Top = 1
          Width = 517
          Height = 62
          Align = alClient
          Alignment = taCenter
          AutoSize = False
          WordWrap = True
          ExplicitLeft = 0
          ExplicitTop = 6
        end
      end
    end
    object TabSheet3: TTabSheet
      Caption = #1057#1090#1072#1090#1080#1089#1090#1080#1082#1072
      ImageIndex = 2
      object ttStatKills: TLabel
        Left = 16
        Top = 16
        Width = 121
        Height = 21
        Caption = 'ttStatKills'
      end
      object ttStatDeads: TLabel
        Left = 16
        Top = 43
        Width = 121
        Height = 21
        Caption = 'ttStatDeads'
      end
      object ttStatBossKills: TLabel
        Left = 16
        Top = 70
        Width = 165
        Height = 21
        Caption = 'ttStatBossKills'
      end
    end
  end
end
